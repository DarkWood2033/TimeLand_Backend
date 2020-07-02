<?php

namespace App\Services\Localization;

use App\Services\Caching\CachingRepository;
use App\Services\Utils\EnvironmentUtil;
use App\Services\Utils\Module;
use Illuminate\Contracts\Translation\Translator;

class LangService
{
    private const CACHE_KEY = 'localization.';

    private const CACHE_TTL = 86400;

    private const TEMPLATE = "/(\:)(\w+)/";

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var CachingRepository
     */
    private $cachingRepository;

    public function __construct(Translator $translator, CachingRepository $cachingRepository)
    {
        $this->translator = $translator;
        $this->cachingRepository = $cachingRepository;
    }

    public function load($locale = null)
    {
        if(!$locale) $locale = $this->translator->getLocale();

        if(EnvironmentUtil::inProduction()){
            $key = self::CACHE_KEY . $locale;
            return $this->cachingRepository->get($key, function() use($key, $locale){
                $data = $this->build($locale);
                $this->cachingRepository->set($key, $data, self::CACHE_TTL);
                return $data;
            });
        }else{
            return $this->build($locale);
        }
    }

    public function validate()
    {
        $all_lang = $this->getAllLang();

        $lang = $this->build(current($all_lang));
        while($lang_two = $this->build(next($all_lang))){
            if($result = array_diff_key($lang, $lang_two)){
                $lang_one = $all_lang[0];
                $lang_two = current($all_lang);
                return [
                    'lang' => [$lang_one, $lang_two],
                    'conflict' => $result
                ];
            }
        }

        return true;
    }

    public static function getAllLang()
    {
        $lang = [];
        $files = glob(resource_path("lang/*"));
        foreach ($files as $file){
            if(is_dir($file)){
                $lang[] = basename($file);
            }
        }

        return $lang;
    }

    private function build($locale): array
    {
        $data = $this->getModuleLang($locale);
        $files = glob(resource_path("lang/{$locale}/*.php"));
        foreach ($files as $file) {
            $name = basename($file, '.php');
            if($lang = $this->translator->get($name)){
                $data[$name] = $lang;
            }
        }

        return $data;
    }

    private function getModuleLang($locale)
    {
        $data = [];
        $namespace = Module::get();
        $url = config('module.'.$namespace.'.lang');
        $files = glob($url."/{$locale}/*.php");

        foreach ($files as $file) {
            $name = basename($file, '.php');
            if($lang = $this->translator->get($namespace.'::'.$name)){
                $data[$name] = $lang;
            }
        }

        return $data;
    }

    private function replace($data)
    {
        if(is_array($data)){
            foreach ($data as $key => $string){
                $data[$key] = $this->replace($string);
            }
            return $data;
        }else{
            return preg_replace(self::TEMPLATE, '{$2}', $data);
        }
    }
}

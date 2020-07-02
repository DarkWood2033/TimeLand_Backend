function Validation(HandlerRules){
    function getRules(rules){
        return rules.split('|')
    }

    function getNameAndArgs(rule){
        return rule.split(':')
    }

    function getArgs(args) {
        return args.split(',');
    }

    function getHandleRule(name, args) {
        if(args){
            args = getArgs(args);
            return HandlerRules[name](...args);
        }else{
            return HandlerRules[name];
        }
    }

    return {
        make(fields, rules, messages = {}){
            let errors = {};
            for(let field in rules){
                let done = this.validate(field, fields[field], rules[field], messages);

                if(done !== true){
                    errors[field] = [done];
                }
            }

            return errors;
        },
        validate(field, value, rule, message = {}){
            let rules = getRules(rule);
            for(let rule in rules){
                let [func_name, args] = getNameAndArgs(rules[rule]);

                let func = getHandleRule(func_name, args);

                let done = func(value, field, message[field+'.'+func_name]);

                if(done !== true){
                    return done;
                }
            }

            return true;
        }
    };
}

export default Validation;

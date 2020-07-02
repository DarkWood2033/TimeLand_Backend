export default {
    max: (limit = 0) => (value, field, message) => value && value.length <= limit || message || $t('validation.max', {attribute: $t('attribute.'+field), max: limit}),
    min: (limit = 0) => (value, field, message) => value && value.length >= limit || message || $t('validation.min', {attribute: $t('attribute.'+field), min:limit}),
    required: (value, field, message) => !!value || message || $t('validation.required', {attribute: $t('attribute.'+field)}),
    email: (value, field, message) => !!value.match(/^[0-9a-z-\.]+\@[0-9a-z-]{2,}\.[a-z]{2,}$/i) || message || $t('validation.email', {attribute: $t('attribute.'+field)}),
    confirmation: (field_confirm = '') => (value, field, message) => field_confirm === value || message || $t('validation.confirmed', {attribute: $t('attribute.'+field)}),
    unique: (values = []) => (value, field, message) => !values.some(item => item === value) || message || $t('validation.unique', {attribute: $t('attribute.'+field)})
};

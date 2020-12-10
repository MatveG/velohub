import {maxLength, minLength, required} from "vuelidate/lib/validators";
import numeric from "vuelidate/lib/validators/numeric";
import integer from "vuelidate/lib/validators/integer";

export const validationsByType = {
    methods: {
        validationsByType(type) {
            switch (type) {
                case 'number':
                    return {
                        required,
                        numeric
                    };

                case 'integer':
                    return {
                        required,
                        integer
                    };

                case 'text':
                    return {
                        required,
                        minLength: minLength(15),
                        maxLength: maxLength(15000)
                    };

                case 'bool':
                    return {
                        required
                    };

                case 'multiple':
                    return {
                        required,
                        minLength: minLength(1),
                        $each: {
                            required
                        }
                    };

                default:
                    return {
                        required,
                        minLength: minLength(3),
                        maxLength: maxLength(255)
                    }
            }
        }
    }
};

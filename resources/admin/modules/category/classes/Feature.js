
import {required, requiredIf, minLength} from "vuelidate/lib/validators";

const types = [
    'группа',
    'строка',
    'число',
    'текст',
    'выбор',
    'есть/нет',
];

export default class Feature {
    constructor(product) {
        this.id = null;
        this.ord = null;
        this.title = null;
        this.latin = null;
        this.type = null;
        this.reset();
    }

    reset() {
        this.required = false;
        this.filter = false;
        this.units = null;
        this.values = [];
        this.sub = [];
    }

    static validations() {
        return {
            title: {
                required,
                minLength: minLength(2)
            },

            type: {
                required,
            },

            values: {
                required: requiredIf(function () {
                    return this.item.type === 'select';
                }),
                minLength: minLength(1),
            }
        }
    }

    static fromObj(obj) {
        return Object.assign(new Feature(), JSON.parse(JSON.stringify(obj)));
    }

    static getTypes(withGroup = true) {
        return withGroup ? types : types.slice(1);
    }

}

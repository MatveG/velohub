
import {customAlphabet} from "nanoid";

const nanoid = customAlphabet('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 9);

export const createKey = {
    methods: {
        createKey(length = 9) {
                return nanoid(length);
        }
    }
};

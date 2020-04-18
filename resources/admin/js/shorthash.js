
function bitwise(str) {
    let hash = 0;

    if (str.length === 0) return hash;

    for (let i = 0; i < str.length; i++) {
        let ch = str.charCodeAt(i);
        hash = ((hash<<5)-hash) + ch;
        hash = hash & hash;
    }

    return hash;
}

function binaryTransfer(integer, binary) {
    binary = binary || 62;
    let stack = [];
    let num;
    let result = '';
    let sign = integer < 0 ? '-' : '';

    function table (num) {
        let t = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return t[num];
    }

    integer = Math.abs(integer);

    while (integer >= binary) {
        num = integer % binary;
        integer = Math.floor(integer / binary);
        stack.push(table(num));
    }

    if (integer > 0) {
        stack.push(table(integer));
    }

    for (let i = stack.length - 1; i >= 0; i--) {
        result += stack[i];
    }

    return sign + result;
}

export default function hash(string) {
    let id = binaryTransfer(bitwise(string), 61);

    return id.replace('-', 'Z');
}



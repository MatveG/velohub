export default function applySorting({name, value}) {
    const shards = window.location.search.substring(1).split('&');
    let append = true;

    const result = shards.map((el) => {
        if (el.startsWith(`${name}=`)) {
            el = `${name}=${value}`;
            append = false;
        }
        return el;
    });
    append && result.push(`${name}=${value}`);

    window.location = '?' + result.join('&');
}

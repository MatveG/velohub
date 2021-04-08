export default function applySorting({target}) {
    const {name, value} = target;
    const urlParams = location.search.split('?').join('');
    const paramPieces = urlParams.includes('&') ? urlParams.split('&') : [];
    const sortingIndex = paramPieces.findIndex((el) => el.startsWith(`${name}=`));

    if (sortingIndex >= 0) {
        paramPieces[sortingIndex] = `${name}=${value}`;
    } else {
        paramPieces.push(`${name}=${value}`);
    }
    window.location = '?' + paramPieces.join('&');
}

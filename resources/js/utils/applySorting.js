export default function applySorting({target}) {
    const {name, value} = target;
    const urlParams = location.search.split('?').join('');
    const paramPieces = urlParams.split('&');
    const sortIndex = paramPieces.findIndex((el) => el.startsWith(`${name}=`));

    if (sortIndex >= 0) {
        paramPieces[sortIndex] = `${name}=${value}`;
    } else {
        paramPieces.push(`${name}=${value}`);
    }

    window.location = '?' + paramPieces.join('&');
}

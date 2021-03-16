export default ({name, value, type, checked}) => {
    const shards = window.location.pathname.split('/');
    const newQuery = [];
    const firsIn = [];
    let flag = true;

    for (let i = 0; i < shards.length; i++) {
        if (!shards[i]) continue;

        if (!shards[i].includes('-is-')) {
            firsIn.push(shards[i]);
            continue;
        }

        const urlKey = shards[i].substr(0, shards[i].indexOf('-is-'));
        const urlVal = shards[i].substr(shards[i].indexOf('-is-') + 4);

        if (!urlKey || !urlVal) continue;

        if ((urlKey === 'price-min' || urlKey === 'price-max') && name === urlKey) {
            if (value) {
                newQuery.push(urlKey + '-is-' + value);
                flag = false;
            }
        } else if (name === urlKey) {
            const urlValues = urlVal.split('-or-');
            const newValues = [];

            for (let n = 0; n < urlValues.length; n++) {
                if (urlValues[n] !== value) {
                    newValues.push(urlValues[n]);
                    continue;
                }
                flag = false;
            }

            if (type === 'checkbox' && checked) {
                newValues.push(value);
            }

            if (type === 'text' && value) {
                newValues.push(value);
            }

            if (newValues.length > 0) {
                newQuery.push(urlKey + '-is-' + newValues.join('-or-'));
                flag = false;
            }
        } else newQuery.push(urlKey + '-is-' + urlVal);
    }

    if (flag === true) {
        newQuery.push(name + '-is-' + value);
    }

    window.location = '/' + sortAndCombineQuery(newQuery, firsIn) + '/' + window.location.search;
};

function sortAndCombineQuery(newQuery, firsIn) {
    let secondIn = [];
    const thirdIn = [];

    for (let i = 0; i < newQuery.length; i++) {
        if (newQuery[i].startsWith('price-min')) {
            secondIn[0] = newQuery[i];
            continue;
        }
        if (newQuery[i].startsWith('price-max')) {
            secondIn[1] = newQuery[i];
            continue;
        }
        if (newQuery[i].startsWith('brand')) {
            secondIn[2] = newQuery[i];
            continue;
        }

        thirdIn.push(newQuery[i]);
    }
    secondIn = secondIn.filter((value) => value !== undefined);

    return [...firsIn, ...secondIn, ...thirdIn.sort()].join('/');
}


$(() => {
    $('.category-select-sort').on('change', applySorting);
    $('.category-filter-input').on('change', applyFilter);
    $('.category-filter-checkbox').on('click', applyFilter);
});

function applySorting() {
    let urlParts = window.location.search.substring(1).split('&');
    let name = this.name;
    let value = this.value;
    let flag = true;

    for (let i = 0; i < urlParts.length; i++) {
        if (!urlParts[i].startsWith(name + '=')) continue;

        urlParts[i] = `${name}=${value}`;
        flag = false;
    }

    if (flag === true) {
        urlParts[urlParts.length] = name + '=' + value;
    }

    window.location = '?' + urlParts.join('&');
}

function applyFilter() {
    let name = this.name;
    let value = this.value;
    let urlParts = window.location.pathname.split('/');
    let newQuery = [], firsIn = [];
    let flag = true;

    for (let i = 0; i < urlParts.length; i++) {
        if (!urlParts[i]) continue;

        if (!urlParts[i].includes('-is-')) {
            firsIn.push(urlParts[i]);
            continue;
        }

        let urlKey = urlParts[i].substr(0, urlParts[i].indexOf('-is-'));
        let urlVal = urlParts[i].substr(urlParts[i].indexOf('-is-') + 4);

        if (!urlKey || !urlVal) continue;

        if ((urlKey === 'price-min' || urlKey === 'price-max') && name === urlKey) {
            if (value) {
                newQuery.push(urlKey + '-is-' + value);
                flag = false;
            }
        } else if (name === urlKey) {
            let urlValues = urlVal.split('-or-');
            let newValues = [];

            for (let n = 0; n < urlValues.length; n++) {
                if (urlValues[n] !== value) {
                    newValues.push(urlValues[n]);
                    continue
                }
                flag = false;
            }

            if (this.type === 'checkbox' && this.checked) {
                newValues.push(value);
            }

            if (this.type === 'text' && value) {
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
}

function sortAndCombineQuery(newQuery, firsIn) {
    let secondIn = [], thirdIn = [];

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
    secondIn = secondIn.filter(value => value !== undefined);

    return [...firsIn, ...secondIn, ...thirdIn.sort()].join('/');
}

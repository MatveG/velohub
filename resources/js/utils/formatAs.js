export function formatAsPrice(number) {
    return new Intl.NumberFormat('ua-UA').format(number);
};

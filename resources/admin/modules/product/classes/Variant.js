
export default class Variant {
    constructor(product) {
        this.id = null;
        this.stock = 0;
        this.price = 0;
        this.surcharge = 0;
        this.parameters = {};
        this.images = [];
    }

    static fromProduct(product) {
        return Object.assign(new Variant(), {
            product_id: product.id,
            category_id: product.category_id,
            is_active: product.is_active,
            is_sale: product.is_sale,
            price: (product.is_sale) ? product.price_sale : product.price
        });
    }

    static fromObj(obj) {
        return Object.assign(new Variant(), JSON.parse(JSON.stringify(obj)));
    }

}

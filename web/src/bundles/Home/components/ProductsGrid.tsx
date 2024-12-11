import {Component} from "react";
import {Product as productType} from "../../../types/product.ts";
import Product from "./Product.tsx";

type IProductsGridProps = {
    products: productType[],
    addToCart: (product: productType) => void,
    navigate: (url: string) => void
}

class ProductsGrid extends Component<IProductsGridProps> {
    render() {
        const {products, addToCart, navigate} = this.props;
        return (
            <div
                className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-12 gap-x-12 "
            >
                {products.map((product) => {
                    return <Product key={product.id} product={product} addToCart={addToCart} navigate={navigate}/>
                })}
            </div>
        );
    }
}

export default ProductsGrid;
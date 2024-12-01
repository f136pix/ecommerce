import {Component} from "react";
import {Product as productType} from "../../../types/product.ts";
import Product from "./Product.tsx";

type IProductsGridProps = {
    products: productType[]
}

class ProductsGrid extends Component<IProductsGridProps> {
    render() {
        const {products} = this.props;
        return (
            // <div className="grid grid-cols-3 gap-4 space-b bg-pink-800 justify-items-stretch">
            <div
                className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-12 gap-x-12 ">
                {products.map((product) => {
                    return <Product key={product.id} product={product}/>
                })}
            </div>
        );
    }
}

export default ProductsGrid;
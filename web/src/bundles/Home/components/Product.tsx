import {Component} from "react";
import {Product as productType} from "../../../types/product.ts";
import AddToCartIcon from "../../../assets/icons/AddCartIcon.png"

type IProductProps = {
    product: productType,
    addToCart: (product: productType) => void,
    navigate: (url: string) => void
}

class Product extends Component<IProductProps> {
    render() {
        const {product, addToCart, navigate} = this.props;

        const isOutOfStock = !product.inStock;

        return (
            <div
                className={`bg-white overflow-hidden p-4 hover:shadow-2xl transition-all group`}>
                <div className="relative cursor-pointer"
                     onClick={() => navigate(`/product/${product.id}`)}>
                    <img src={product?.images[0]?.url} alt={"image " + product.name}
                         className="w-full h-72 object-cover object-top"/>
                    {isOutOfStock && (
                        <div className="absolute inset-0 flex items-center justify-center bg-inactive-bg bg-opacity-80">
                            <p className="text-lg uppercase text-tertiary">out of stock</p>
                        </div>
                    )}
                </div>
                <div className="py-4">
                    <div className={"flex justify-between"}>
                        <p className="text-primary font-normal">{product?.name}</p>
                        {!isOutOfStock && <div className={"z-50"}>
                            <img src={AddToCartIcon}
                                 className={"hidden group-hover:flex text-tertiary -mt-10 mr-4 h-12 z-50 cursor-pointer"}
                                 alt={"cart-icon"}
                                 onClick={() => addToCart(product)}
                            >
                            </img>
                        </div>}
                    </div>
                    <h3 className="text-lg font-medium">${product?.price}</h3>
                </div>
            </div>
        );


        // return (
        //     <div className="bg-white overflow-hidden p-4 cursor-pointer hover:shadow-2xl transition-all group">
        //         <img src={product?.images[0]?.url} alt={"image " + product.name}
        //              className="w-full h-72 object-cover object-top"/>
        //         <div className="py-4">
        //             <div className={"flex justify-between"}>
        //                 <p className="text-primary font-normal">{product?.name}</p>
        //                 <div className={"h-0"}>
        //                     <img src={AddToCartIcon}
        //                          className={"hidden group-hover:flex text-secondary -mt-10 mr-4 h-12"}
        //                          alt={"cart-icon"}>
        //                     </img>
        //                 </div>
        //             </div>
        //             <h3 className="text-lg font-medium">${product?.price}</h3>
        //         </div>
        //     </div>
        // );
    }
}

export default Product;
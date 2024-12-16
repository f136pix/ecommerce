import {Component} from 'react';
import {ProductPageProps} from "./index.tsx";
import ImagesBar from "./components/ImagesBar.tsx";
import {Image as ImageType, Product} from "../../types/product.ts";
import ImagesList from "./components/ImagesList.tsx";
import CartSection from "./components/CartSection.tsx";


export interface ImagesSectionProps {
    images: ImageType[];
    currentImage?: ImageType;
    setCurrentImage: (image: ImageType) => void;
}

class ProductPage extends Component<ProductPageProps> {

    render() {
        const {productStore,addToCart} = this.props;
        return (
            <main className={"w-full mx-auto flex space-x-4 mt-16 pb-12 px-28"}>
                <ImagesBar images={productStore.product?.images!} setCurrentImage={productStore.setCurrentImage}/>
                <ImagesList images={productStore.product?.images!} currentImage={productStore.currentImage!} setCurrentImage={productStore.setCurrentImage}/>
                <CartSection product={productStore.product!} addToCart={addToCart}/>


            </main>
        );
    }
}

export default ProductPage;
import {Component} from 'react';
import {ProductPageProps} from "./index.tsx";
import ImagesBar from "./components/ImagesBar.tsx";
import {Image as ImageType} from "../../types/product.ts";
import Image from "./components/Image.tsx";
import CartSection from "./components/CartSection.tsx";


export interface ImagesSectionProps {
    images: ImageType[];
    currentImage?: ImageType;
    setCurrentImage: (image: ImageType) => void;
}

class ProductPage extends Component<ProductPageProps> {

    render() {
        const {productStore} = this.props;
        return (
            <main className={"w-full mx-auto flex space-x-4 mt-16 pb-12"}>
                <ImagesBar images={productStore.product?.images!} setCurrentImage={productStore.setCurrentImage}/>
                <Image images={productStore.product?.images!} currentImage={productStore.currentImage!} setCurrentImage={productStore.setCurrentImage}/>
                <CartSection product={productStore.product!}/>


            </main>
        );
    }
}

export default ProductPage;
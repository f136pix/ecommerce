import {Component} from 'react';
import {ProductPageProps} from "./index.tsx";
import ImagesBar from "./components/ImagesBar.tsx";
import CartSection from "./components/CartSection.tsx";
import {Image as ImageType} from "../../types/product.ts";
import Image from "./components/Image.tsx";

export interface ImagesSectionProps {
    images: ImageType[];
    currentImage?: string;
    setCurrentImage: (image: string) => void;
}

class ProductPage extends Component<ProductPageProps> {

    render() {
        const {productStore} = this.props;
        return (
            <main className={"w-full mx-auto flex"}>
                <ImagesBar images={productStore.product?.images!} setCurrentImage={productStore.setCurrentImage}/>
                <Image images={productStore.product?.images!} currentImage={productStore.currentImage!} setCurrentImage={productStore.setCurrentImage}/>
                <CartSection />


            </main>
        );
    }
}

export default ProductPage;
import {Component} from 'react';
import {ImagesSectionProps} from "../ProductPage.tsx";
import CaretLeft from "../../../assets/icons/CaretLeft.png";

class ImagesList extends Component<ImagesSectionProps> {
    handleNextImage = () => {
        const {images, currentImage, setCurrentImage} = this.props;
        const currentIndex = images.findIndex(image => image === currentImage);
        const nextIndex = (currentIndex + 1) % images.length;
        setCurrentImage(images[nextIndex]);
    };

    handlePreviousImage = () => {
        const {images, currentImage, setCurrentImage} = this.props;
        const currentIndex = images.findIndex(image => image === currentImage);
        const previousIndex = (currentIndex - 1 + images.length) % images.length;
        setCurrentImage(images[previousIndex]);
    };

    render() {
        const {currentImage} = this.props;

        return (
            <div className="relative flex h-[30rem] w-6/12 bg-transparent" data-testid='product-gallery'>
                <button onClick={this.handlePreviousImage}
                        className="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-1 rounded-none ml-5">
                    <img src={CaretLeft} className="filter invert h-4"/>
                </button>
                <img src={currentImage?.url} alt="Product" className="mx-auto w-full h-auto object-cover object-top"/>
                <button onClick={this.handleNextImage}
                        className="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-1 mr-5 rounded-none">
                    <img src={CaretLeft} className="filter invert h-4 rotate-180"/>
                </button>
            </div>
        );
    }
}

export default ImagesList;
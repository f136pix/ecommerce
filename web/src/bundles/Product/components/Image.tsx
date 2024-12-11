import {Component} from 'react';
import {ImagesSectionProps} from "../ProductPage.tsx";

class Image extends Component<ImagesSectionProps> {
    handleNextImage = () => {
        const { images, currentImage, setCurrentImage } = this.props;
        const currentIndex = images.findIndex(image => image === currentImage);
        const nextIndex = (currentIndex + 1) % images.length;
        setCurrentImage(images[nextIndex]);
    };

    handlePreviousImage = () => {
        const { images, currentImage, setCurrentImage } = this.props;
        const currentIndex = images.findIndex(image => image === currentImage);
        const previousIndex = (currentIndex - 1 + images.length) % images.length;
        setCurrentImage(images[previousIndex]);
    };

    render() {
        const { currentImage } = this.props;

        return (
            <div className="relative flex h-[30rem] w-6/12 bg-transparent">
                <button onClick={this.handlePreviousImage}
                        className="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-none">
                    &#8592;
                </button>
                <img src={currentImage?.url} alt="Product" className="mx-auto w-full h-auto object-cover object-top"/>
                <button onClick={this.handleNextImage}
                        className="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-none">
                    &#8594;
                </button>
            </div>
        );
    }
}

export default Image;
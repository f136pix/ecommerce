import {Component} from 'react';
import {ImagesSectionProps} from "../ProductPage.tsx";

class ImagesBar extends Component<ImagesSectionProps> {
    render() {
        const {images, setCurrentImage} = this.props;
        const visibleImages = images.slice(0, 5);

        return (
            <div className="flex flex-col h-[30rem] max-h-[30rem] w-1/12 overflow-y-scroll space-y-2 scrollbar-hide">
                {visibleImages.map((image, index) => (
                    <img
                        key={index}
                        src={image.url}
                        alt={`Thumbnail ${index + 1}`}
                        className="h-[6rem] object-cover cursor-pointer"
                        onClick={() => setCurrentImage(image)}
                    />
                ))}
            </div>
        );
    }
}

export default ImagesBar;

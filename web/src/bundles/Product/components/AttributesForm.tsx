import {Component} from "react";

import {Product} from "../../../types/product.ts";
import {cn} from "../../../utils";


type AttributeRadioProps = {
    product: Product,
    addToCart: (product: Product, productAttributeValueIds: string[]) => void;
}

type IAttributesFormProps = {
    selectedValues: { [key: string]: string };
    isAllAttributesSelected: boolean;
}

class AttributesForm extends Component<AttributeRadioProps, IAttributesFormProps> {
    constructor(props: AttributeRadioProps) {
        super(props);
        const initialSelectedValues: { [key: string]: string } = {};
        this.state = {
            selectedValues: initialSelectedValues,
            isAllAttributesSelected: false
        };
    }

    handleSelect = (attributeName: string, value: string) => {
        this.setState(prevState => {
            const selectedValues = {
                ...prevState.selectedValues,
                [attributeName]: value
            };
            const isAllAttributesSelected = Object.keys(selectedValues).length === this.props.product.attributes.length;
            return {
                selectedValues,
                isAllAttributesSelected
            };
        });
    };

    render() {
        const {product, addToCart} = this.props;
        const {selectedValues, isAllAttributesSelected} = this.state;

        const attributes = product.attributes;
        const price = product.price;

        return (
            <div>
                {attributes.map((attribute) => (
                    <div
                        key={attribute.name}
                        className={"mb-8"}
                        data-testid={`product-attribute-${attribute.name.toLowerCase()}`}>
                        <h3 className={"font-bold uppercase text-sm mb-1"}>{attribute.name + ":"}</h3>
                        <div className={"flex"}>
                            {attribute.values.map((attributeValue) => (
                                <label key={attributeValue.id} className="relative mx-0.5 cursor-pointer">
                                    <input
                                        type="radio"
                                        name={attribute.name}
                                        value={attributeValue.value}
                                        checked={selectedValues[attribute.name] === attributeValue.value}
                                        onChange={() => this.handleSelect(attribute.name, attributeValue.id)}
                                        className="absolute w-full h-full opacity-0 cursor-pointer z-50"
                                        data-testid={`product-attribute-${attribute.name.toLowerCase()}-${attributeValue.value}`}
                                    />
                                    <div
                                        className={
                                            `flex items-center justify-center ${selectedValues[attribute.name] === attributeValue.id && attribute.name == "Color"
                                                ? 'border-[0.13rem] border-green-500'
                                                : 'border'
                                            } 
                                            ${attribute.name === "Color"
                                                ? 'w-8 h-8'
                                                : 'w-16 h-10 border-black text-base'
                                            } 
                                            ${selectedValues[attribute.name] === attributeValue.id
                                            && attribute.name !== "Color"
                                                ? 'bg-primary text-white' : 'text-black'
                                            }
                                        `}
                                        style={{backgroundColor: attribute.name === "Color" ? attributeValue.value : ''}}
                                    >
                                        {attribute.name !== "Color" && (
                                            <span
                                                className="absolute inset-0 flex items-center justify-center font-normal pointer-events-none">
                                                {attributeValue.value}
                                            </span>
                                        )}
                                    </div>
                                </label>
                            ))}
                        </div>
                    </div>
                ))}
                <h3 className={"font-bold uppercase text-sm mb-1"}>price:</h3>
                <h2 className={"font-bold uppercase text-xl mb-8"}>{"$" + price}</h2>

                <button
                    className={cn("bg-secondary-bg uppercase text-neutral-50 rounded-none text-base w-[70%] mb-8", (!product.inStock || !isAllAttributesSelected) && "cursor-not-allowed bg-gray-400")}
                    data-testid='add-to-cart'
                    disabled={!product.inStock || !isAllAttributesSelected}
                    onClick={() => addToCart(product, Object.values(selectedValues))}
                >
                    {!product.inStock ? "out of stock" : "add to cart"}
                </button>
            </div>
        );
    }
}

export default AttributesForm;
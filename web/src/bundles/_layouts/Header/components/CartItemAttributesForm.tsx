import {Component} from "react";
import {CartProviderState} from "react-use-cart";

import {Product} from "../../../../types/product.ts";
import {concatenateId} from "../../../../utils";

type CartItemAttributesProps = {
    product: Product;
    selectedValues: { [key: string]: string };
    cartStore: CartProviderState;
    itemId: string;
}

type CartItemAttributesState = {
    selectedValues: { [key: string]: string };
}

class CartItemAttributesForm extends Component<CartItemAttributesProps, CartItemAttributesState> {
    constructor(props: CartItemAttributesProps) {
        super(props);
        this.state = {
            selectedValues: props.selectedValues
        };
    }

    handleSelect = (attributeName: string, value: string) => {
        this.setState(prevState => {
            const selectedValues = {
                ...prevState.selectedValues,
                [attributeName]: value
            };

            const productAttributeValueIds = Object.values(selectedValues);
            const newItemId = concatenateId(productAttributeValueIds);

            this.props.cartStore.updateItem(this.props.itemId, {
                id: newItemId,
                productAttributeValueIds
            });

            return {selectedValues};
        });
    };

    render() {
        const {product} = this.props;
        const {selectedValues} = this.state;

        return (
            <div className={"w-32 max-w-32 min-w-32"}>
                {product.attributes.map((attribute, index) => (
                    <div
                        key={attribute.name}
                        className={index > 0 ? "mt-3" : ""}
                        data-testid={`cart-item-attribute-${attribute.name}`}
                    >
                        <h3 className={"capitalize text-sm mb-1 text-secondary"}>{attribute.name + ":"}</h3>
                        <div className={"flex"}>
                            {attribute.values.map((attributeValue) => (
                                <label
                                    key={attributeValue.id}
                                    className="relative mr-1.5 cursor-pointer"
                                    data-testid={selectedValues[attribute.name] === attributeValue.id
                                        ? `cart-item-attribute-${attribute.name}-${attribute.name}-selected`
                                        : `cart-item-attribute-${attribute.name}-${attribute.name}`}
                                >
                                    <input
                                        type="radio"
                                        name={attribute.name}
                                        value={attributeValue.value}
                                        checked={selectedValues[attribute.name] === attributeValue.id}
                                        onChange={() => this.handleSelect(attribute.name, attributeValue.id)}
                                        className="absolute w-full h-full opacity-0 cursor-pointer"
                                    />
                                    <div
                                        className={`flex items-center justify-center ${selectedValues[attribute.name] === attributeValue.id && attribute.name === "Color"
                                            ? 'border-[0.12rem] border-green-400'
                                            : 'border'} 
                                            ${attribute.name === "Color"
                                            ? 'w-4 h-4'
                                            : attribute.name === "Capacity"
                                                ? 'w-10 h-6 border-black text-xs'
                                                : 'w-6 h-6 border-black text-xs'} 
                                            ${selectedValues[attribute.name] === attributeValue.id && attribute.name !== "Color"
                                            ? 'bg-primary text-white' : 'text-black'}`}
                                        style={{backgroundColor: attribute.name === "Color" ? attributeValue.value : ''}}
                                    >
                                        {attribute.name !== "Color" && (
                                            <span
                                                className="absolute inset-0 flex items-center justify-center font-normal">
                                                {attributeValue.value}
                                            </span>
                                        )}
                                    </div>
                                </label>
                            ))}
                        </div>
                    </div>
                ))}
            </div>
        );
    }
}

export default CartItemAttributesForm;
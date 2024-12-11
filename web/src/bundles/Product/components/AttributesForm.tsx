import {Component} from "react";
import { Product} from "../../../types/product.ts";

type AttributeRadioProps = {
    product: Product,
}

type AttributeRadioState = {
    selectedValues: { [key: string]: string };
}

class AttributesForm extends Component<AttributeRadioProps, AttributeRadioState> {
    constructor(props: AttributeRadioProps) {
        super(props);
        const initialSelectedValues: { [key: string]: string } = {};
        props.product.attributes.forEach(attr => {
            initialSelectedValues[attr.name] = attr.values[0].value;
        });
        this.state = {
            selectedValues: initialSelectedValues
        };
    }

    handleSelect = (attributeName: string, value: string) => {
        this.setState(prevState => ({
            selectedValues: {
                ...prevState.selectedValues,
                [attributeName]: value
            }
        }));
    }

    render() {
        const {product} = this.props;
        const {selectedValues} = this.state;

        const attributes = product.attributes;
        const price = product.price;

        return (
            <div>
                {attributes.map((attribute) => (
                    <div key={attribute.name} className={"mb-5"}>
                        <h3 className={"font-bold uppercase text-sm mb-1"}>{attribute.name + ":"}</h3>
                        <div className={"flex"}>
                            {attribute.values.map((attributeValue) => (
                                <label key={attributeValue.id} className="relative mx-0.5 cursor-pointer">
                                    <input
                                        type="radio"
                                        name={attribute.name}
                                        value={attributeValue.value}
                                        checked={selectedValues[attribute.name] === attributeValue.value}
                                        onChange={() => this.handleSelect(attribute.name, attributeValue.value)}
                                        className="absolute w-full h-full opacity-0 cursor-pointer"
                                    />
                                    <div
                                        className={
                                            `flex items-center justify-center ${selectedValues[attribute.name] === attributeValue.value
                                                ? 'border-[0.14rem] border-green-400'
                                                : 'border'
                                            } 
                                            ${attribute.name === "Color"
                                                ? 'w-7 h-7'
                                                : 'w-20 h-10 border-black text-base'
                                            } 
                                            ${selectedValues[attribute.name] === attributeValue.value
                                            && attribute.name !== "Color"
                                                ? 'bg-black text-white' : 'text-black'}
                                        `}
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
                <h3 className={"font-bold uppercase text-sm mb-1"}>price:</h3>
                <h3 className={"font-bold uppercase text-xl mb-1"}>{"$" + price}</h3>
            </div>
        );
    }
}

export default AttributesForm;
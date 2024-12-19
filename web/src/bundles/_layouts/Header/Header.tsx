import {Component} from 'react';
import {Link} from "react-router-dom";

import cartIcon from "../../../assets/icons/EmptyCartIcon.png";
import logo from "../../../assets/logo.png";
import storeProvider from "../../../common/storeProvider.tsx";
import {cn} from "../../../utils";

import CartSection from "./components/CartSection.tsx";
import {HeaderProps} from "./index.tsx";

const selectedNavStyle = "text-secondary-bg hover:text-secondary-bg font-semibold h-full flex items-center justify-center after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-[160%] after:border-b-2 after:border-secondary-bg";
const navStyle = "text-primary font-normal text-lg relative hover:text-primary";

class Header extends Component<HeaderProps> {
    render() {
        const {currentCategory, cartStore, placeOrder} = this.props;
        const {categories, toggleCart, isCartOpen} = this.props.headerStore;

        return (
            <nav className="h-20 flex justify-between bg-primary-bg px-28 relative">
                <div className="flex-1">
                    <ul className="my-auto h-full w-8/12 flex items-center justify-between capitalize tracking-wider">
                        {categories.map((category, index) => {
                            return (
                                <Link
                                    key={index}
                                    to={`/home/${category}`}
                                    className={cn(cn(navStyle, index == 0 && "ml-[7%]"),
                                        currentCategory == category ? selectedNavStyle : "cursor-pointer")}
                                    data-testid={currentCategory == category ? 'active-category-link' : 'category-link'}
                                >
                                    {category}
                                </Link>
                            );
                        })}
                    </ul>
                </div>
                <div className="flex-1 flex items-center justify-center">
                    <img src={logo} alt="Logo" className="h-10"/>
                </div>
                <div className="flex-1 flex items-center justify-end relative">
                    <button className="relative cursor-pointer w-auto bg-transparent p-0" onClick={toggleCart}
                            data-testid={'cart-btn'}>
                        <img
                            src={cartIcon}
                            alt="Cart"
                            className="h-6 mr-[4%]"
                        />
                        {cartStore.items.length > 0 && (
                            <div
                                className="absolute top-[-4px] right-[-4px] bg-black text-white rounded-full h-4 w-4 flex items-center justify-center text-xs ml-6 mb-12">
                                <p className={"mb-[0.1rem] font-medium"}>{cartStore.totalItems}</p>
                            </div>
                        )}
                    </button>
                    {isCartOpen && <CartSection cartStore={cartStore} placeOrder={placeOrder}/>}
                </div>
            </nav>
        );
    }
}

export default storeProvider(Header);
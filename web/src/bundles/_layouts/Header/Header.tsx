import {Component} from 'react';
import {HeaderProps} from "./index.tsx";
import logo from "../../../assets/logo.png";
import cartIcon from "../../../assets/icons/EmptyCartIcon.png";
import {cn} from "../../../utils";
import CartSection from "./components/CartSection.tsx";

class Header extends Component<HeaderProps> {
    render() {
        const {categories, toggleCart, currentCategory, navigate, isCartOpen, cartStore} = this.props;

        return (
            <nav className="h-20 flex justify-between bg-primary-bg px-28 relative">
                <div className="flex-1">
                    <ul className="my-auto h-full w-8/12 flex items-center justify-between capitalize tracking-wider">
                        {categories.map((category, index) => {
                            const style = cn("text-secondary-bg font-semibold h-full flex items-center justify-center after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-[160%] after:border-b-2 after:border-secondary-bg");
                            return (
                                <li key={index}
                                    className={cn(cn("font-normal text-lg relative", index == 0 ? "ml-[7%]" : ""),
                                        currentCategory == category ?
                                            style
                                            : "cursor-pointer")}
                                    onClick={() => navigate(category)}
                                >
                                    {category}
                                </li>
                            );
                        })}
                    </ul>
                </div>
                <div className="flex-1 flex items-center justify-center">
                    <img src={logo} alt="Logo" className="h-10"/>
                </div>
                <div className="flex-1 flex items-center justify-end relative">
                    <img
                        src={cartIcon}
                        alt="Cart"
                        className="h-6 mr-[4%] cursor-pointer"
                        onClick={toggleCart}
                    />
                    {isCartOpen && <CartSection cartStore={cartStore}/>}
                </div>
            </nav>
        );
    }
}

export default Header;
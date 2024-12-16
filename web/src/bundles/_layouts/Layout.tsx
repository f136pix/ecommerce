import {Component} from 'react';
import {
    Outlet,
} from 'react-router-dom';
import Header from "./Header";

import '../../index.css';

class Layout extends Component<{ isCartOpen: boolean, toggleCart: () => void }> {
    render() {
        const {isCartOpen,toggleCart} = this.props;
        return (
            <div className={"flex flex-col w-12/12 mx-auto "}>
                <Header/>
                <div 
                    // className={`${isCartOpen ? 'darken z-50 min-h-screen' : ''}`}
                    className={`${isCartOpen ? 'darken z-50 min-h-screen' : ''}`}
                     onClick={() => isCartOpen ? toggleCart() : null}
                >
                    <Outlet/>
                </div>
            </div>
        )
    }
}

export default Layout;
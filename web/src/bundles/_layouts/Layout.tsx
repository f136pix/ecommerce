import {Component} from 'react';
import {
    Outlet,
} from 'react-router-dom';
import Header from "./Header";

class Layout extends Component {
    render() {
        return (
            <div className={"flex flex-col w-10/12 mx-auto "}>
                <Header/>
                <Outlet/>
            </div>
        )
    }
}

export default Layout;
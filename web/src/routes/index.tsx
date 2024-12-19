import {BrowserRouter as Router, Route, Routes} from 'react-router-dom';

import {useHeaderStore} from "../bundles/_layouts/Header/useHeaderStore.tsx";
import Layout from "../bundles/_layouts/Layout.tsx";
import NotFound from "../bundles/_layouts/NotFound.tsx";  
import HomePage from "../bundles/Home/index.tsx";
import ProductPage from "../bundles/Product/index.tsx";


const AppRouter = () => {
    const {isCartOpen,toggleCart } = useHeaderStore();
    
    return (
        <Router>
            <Routes>
                <Route element={<Layout isCartOpen={isCartOpen} toggleCart={toggleCart}/>}>
                    <Route path={"home/:category"} element={<HomePage/>}/>
                    <Route path={"product/:id"} element={<ProductPage/>}/>
                    <Route path="*" element={<NotFound />} />
                </Route>
            </Routes>
        </Router>
    );
};

export default AppRouter;
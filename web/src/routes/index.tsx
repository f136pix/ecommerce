import {BrowserRouter as Router, Route, Routes} from 'react-router-dom';
import Layout from "../bundles/_layouts/Layout.tsx";
import HomePage from "../bundles/Home/index.tsx";
import ProductPage from "../bundles/Product/index.tsx";  


const AppRouter = () => {
    return (
        <Router>
            <Routes>
                <Route element={<Layout/>}>
                    <Route path={"home/:category"} element={<HomePage/>}/>
                    <Route path={"product/:id"} element={<ProductPage/>}/>
                </Route>
            </Routes>
        </Router>
    );
}

export default AppRouter;
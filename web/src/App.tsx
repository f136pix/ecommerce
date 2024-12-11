import AppRouter from "./routes";
import client from "./lib/appoloClient.ts";
import {ApolloProvider} from "@apollo/client";
import {CartProvider} from "react-use-cart";
import 'react-toastify/dist/ReactToastify.css';

const App = () => {


    return (
        <div className={"w-screen h-screen"}>
            <ApolloProvider client={client}>
                <CartProvider>
                    <AppRouter/>
                </CartProvider>
            </ApolloProvider>
        </div>
    );
}
export default App

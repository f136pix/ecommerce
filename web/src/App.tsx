import AppRouter from "./routes";
import client from "./lib/appoloClient.ts";
import {ApolloProvider} from "@apollo/client";

const App = () => {


    return (
        <div className={"w-screen h-screen"}>
            <ApolloProvider client={client}>
                <AppRouter/>
            </ApolloProvider>
        </div>
    );
}
export default App

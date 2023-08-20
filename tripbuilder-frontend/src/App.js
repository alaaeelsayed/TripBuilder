import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import "./App.scss";
import TripSearch from "./components/TripSearch";
import Trips from "./components/Trips";
import { QueryClient, QueryClientProvider } from "react-query";

function App() {
  const queryClient = new QueryClient();

  return (
    <QueryClientProvider client={queryClient}>
      <Router>
        <div className="d-flex flex-column min-vh-100">
          <div className="p-4 mb-5 shadow-4 bg-dark text-white text-center">
            <h1 className="display-1 fw-bold mb-4">Trip Builder 3.0</h1>
            <p className="lead">
              Welcome to the TripBuilder application. You can start searching
              for flights by selecting the from and to locations and pressing
              search.
            </p>
          </div>
          <Routes>
            <Route path="/trips" element={<Trips />} />
            <Route path="/" element={<TripSearch />} />
          </Routes>
        </div>
      </Router>
    </QueryClientProvider>
  );
}

export default App;

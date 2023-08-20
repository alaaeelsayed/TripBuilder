import { useState } from "react";
import { useNavigate } from "react-router-dom";
import AirportSearch from "./AirportSearch";
import { fetchAirports } from "../utils/queries";
import { useQuery } from "react-query";

const TripSearch = () => {
  const navigate = useNavigate();

  const [origin, setOrigin] = useState();
  const [destination, setDestination] = useState();
  const [flightType, setFlightType] = useState("one-way");
  const [validated, setValidated] = useState(false);

  const { data: airports, isLoading } = useQuery(
    "fetchAirports",
    fetchAirports
  );

  return isLoading ? (
    <div
      style={{
        position: "fixed",
        top: "50%",
        left: "50%",
        transform: "translate(-50%, -50%)",
      }}
    >
      <div className="spinner-border text-primary" role="status">
        <span className="visually-hidden">Loading...</span>
      </div>
    </div>
  ) : (
    <form
      noValidate
      onSubmit={(e) => {
        e.preventDefault();
        if (e.currentTarget.checkValidity()) {
          navigate(
            `/trips?from=${origin}&to=${destination}&type=${flightType}`
          );
        }
        setValidated(true);
      }}
      className={`rounded bg-light p-5 w-50 mx-auto shadow${
        validated ? " was-validated" : ""
      }`}
    >
      <div className="d-flex justify-content-center mb-4">
        <div className="btn-group btn-group-lg" role="group">
          <button
            type="button"
            className={`btn ${
              flightType === "one-way" ? "btn-primary" : "btn-outline-primary"
            }`}
            onClick={() => setFlightType("one-way")}
          >
            One Way
          </button>
          <button
            type="button"
            className={`btn ${
              flightType === "roundtrip" ? "btn-primary" : "btn-outline-primary"
            }`}
            onClick={() => setFlightType("roundtrip")}
          >
            Round Trip
          </button>
        </div>
      </div>

      <AirportSearch
        inputLabel="From"
        inputPlaceholder="Leaving from"
        label="Origin"
        airports={airports}
        onSelect={(selected) => setOrigin(selected)}
      />
      <AirportSearch
        inputLabel="To"
        inputPlaceholder="Heading to"
        label="Destination"
        airports={airports}
        onSelect={(selected) => setDestination(selected)}
      />

      <div className="d-grid gap-2">
        <button className="btn btn-lg btn-primary mt-4" type="submit">
          Search
        </button>
      </div>
    </form>
  );
};

export default TripSearch;

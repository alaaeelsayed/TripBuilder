import { useEffect, useMemo, useState } from "react";
import { useQuery } from "react-query";
import { fetchAirlines, fetchTrips } from "../utils/queries";
import { useSearchParams, useNavigate } from "react-router-dom";
import { toStandardTime } from "../utils/time";
import FilterAndSort from "./FilterAndSort";

const Trips = () => {
  const navigate = useNavigate();

  const [searchParams, setSearchParams] = useSearchParams();

  const query = useMemo(
    () => new URLSearchParams(searchParams),
    [searchParams]
  );
  const from = query.get("from");
  const to = query.get("to");
  const type = query.get("type");
  const page = query.get("page") || 1;

  const [currentPage, setCurrentPage] = useState(page);

  const [sort, sortBy] = useState("price");
  const [filter, filterBy] = useState(undefined);
  const [maxDuration, setMaxDuration] = useState(30 * 60); // duration is in minutes
  const [maxPrice, setMaxPrice] = useState(2000);

  const { isLoading: tripsLoading, data: tripsData } = useQuery(
    [
      "fetchTrips",
      from,
      to,
      type,
      currentPage,
      sort,
      filter,
      maxDuration,
      maxPrice,
    ],
    () =>
      fetchTrips({
        from,
        to,
        type,
        page: currentPage,
        sortby: sort,
        airline: filter,
        maxduration: maxDuration,
        maxprice: maxPrice,
      }),
    {
      enabled: !!from && !!to && !!type,
      refetchOnWindowFocus: false,
      staleTime: 1000 * 60 * 5,
    }
  );

  const { isLoading: airlinesLoading, data: airlines } = useQuery(
    "fetchAirlines",
    fetchAirlines,
    {
      staleTime: 1000 * 60 * 60,
    }
  );

  let trips = [];
  let totalPages = 1;
  if (tripsData && tripsData.data && tripsData.pagination) {
    trips = tripsData.data;
    totalPages = tripsData.pagination.total;
  }

  useEffect(() => {
    query.set("page", currentPage);
    setSearchParams(query);
  }, [currentPage, query, setSearchParams]);

  const getAirlineName = (airlineCode) => {
    const airline = airlines.find((a) => a.code === airlineCode);
    return airline ? `${airline.name} (${airline.code})` : airlineCode;
  };

  return (
    <div className="text-dark mt-3 container">
      {!tripsLoading && trips.length > 0 && (
        <h1 className="text-center">
          {trips[0].outbound.departure_airport.city} to{" "}
          {trips[0].outbound.arrival_airport.city}
        </h1>
      )}
      {!airlinesLoading && (
        <>
          <FilterAndSort
            airlines={airlines}
            sortBy={sortBy}
            filterBy={filterBy}
            maxDuration={setMaxDuration}
            maxPrice={setMaxPrice}
          />
          <div className="d-flex justify-content-center mt-3 mb-3">
            <button
              className="btn btn-outline-primary btn-lg"
              onClick={() => navigate("/")}
            >
              <i className="bi bi-arrow-clockwise me-2"></i>
              Search Again
            </button>
          </div>
        </>
      )}
      {tripsLoading || airlinesLoading ? (
        <div className="m-5 text-center">
          <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      ) : trips.length === 0 ? (
        <h3 className="text-center m-5">
          There are currently no flights available for these parameters.
        </h3>
      ) : (
        <>
          {trips.map((trip, index) => (
            <div
              key={index}
              className="row bg-light border rounded-3 p-4 m-2 shadow-lg"
            >
              <div className="col-12 d-flex justify-content-between p-2 mb-3 border-bottom">
                <h4 className="m-0">
                  Total:{" "}
                  <span className="text-primary">${trip.total_price}</span>
                </h4>
              </div>
              <div className="col-md-9">
                <div className="d-flex align-items-center mb-3">
                  <i
                    className="bi bi-airplane text-success"
                    style={{ fontSize: "2rem" }}
                  ></i>
                  <h5 className="ms-3 text-success">
                    Outbound - {getAirlineName(trip.outbound.airline)}
                  </h5>
                </div>
                <div>
                  <span className="me-2">Departure:</span>
                  <strong>
                    {toStandardTime(trip.outbound.departure_time)}
                  </strong>
                  <span className="ms-4 me-2">Arrival:</span>
                  <strong>{toStandardTime(trip.outbound.arrival_time)}</strong>
                </div>
              </div>
              <div className="col-md-3 d-flex flex-column justify-content-center align-items-center text-end">
                <div>
                  <span className="me-2">Price:</span>
                  <strong className="text-primary">
                    ${trip.outbound.price}
                  </strong>
                </div>
                <div>
                  <span className="me-2">Duration:</span>
                  <strong>
                    {Math.floor(trip.outbound.duration / 60)}h{" "}
                    {trip.outbound.duration % 60}m
                  </strong>
                </div>
              </div>

              {trip.inbound && (
                <>
                  <div className="col-12 my-3">
                    <hr className="bg-primary" />
                  </div>
                  <div className="col-md-9">
                    <div className="d-flex align-items-center mb-3">
                      <i
                        className="bi bi-airplane text-danger"
                        style={{
                          fontSize: "2rem",
                          transform: "scaleY(-1)",
                        }}
                      ></i>
                      <h5 className="ms-3 text-danger">
                        Inbound - {getAirlineName(trip.inbound.airline)}
                      </h5>
                    </div>
                    <div>
                      <span className="me-2">Departure:</span>
                      <strong>
                        {toStandardTime(trip.inbound.departure_time)}
                      </strong>
                      <span className="ms-4 me-2">Arrival:</span>
                      <strong>
                        {toStandardTime(trip.inbound.arrival_time)}
                      </strong>
                    </div>
                  </div>
                  <div className="col-md-3 d-flex flex-column justify-content-center align-items-center text-end">
                    <div>
                      <span className="me-2">Price:</span>
                      <strong className="text-primary">
                        ${trip.inbound.price}
                      </strong>
                    </div>
                    <div>
                      <span className="me-2">Duration:</span>
                      <strong>
                        {Math.floor(trip.inbound.duration / 60)}h{" "}
                        {trip.inbound.duration % 60}m
                      </strong>
                    </div>
                  </div>
                </>
              )}
              <div className="col-12 d-flex justify-content-between p-2 mt-3 border-top">
                <small className="m-0">
                  Total Duration: {Math.floor(trip.total_duration / 60)}h{" "}
                  {trip.total_duration % 60}m
                </small>
                <small className="m-0">
                  Total Distance: {trip.total_distance} km
                </small>
              </div>
            </div>
          ))}
          <div className="mt-4 d-flex justify-content-center">
            <ul className="pagination">
              <li className={`page-item ${currentPage <= 1 ? "disabled" : ""}`}>
                <button
                  className="page-link"
                  onClick={() => {
                    setCurrentPage((prev) => Math.max(1, prev - 1));
                  }}
                >
                  <i className="bi bi-chevron-left"></i>
                </button>
              </li>
              {Array.from({ length: totalPages || 1 }, (_, index) => (
                <li
                  key={index}
                  className={`page-item ${
                    currentPage === index + 1 ? "active" : ""
                  }`}
                >
                  <button
                    className="page-link"
                    onClick={() => {
                      setCurrentPage(index + 1);
                    }}
                  >
                    {index + 1}
                  </button>
                </li>
              ))}
              <li
                className={`page-item ${
                  currentPage >= totalPages ? "disabled" : ""
                }`}
              >
                <button
                  className="page-link"
                  onClick={() => {
                    setCurrentPage((prev) =>
                      Math.min(totalPages || 1, prev + 1)
                    );
                  }}
                >
                  <i className="bi bi-chevron-right"></i>
                </button>
              </li>
            </ul>
          </div>
        </>
      )}
    </div>
  );
};

export default Trips;

import React, { useState } from "react";

const FilterAndSort = ({
  airlines,
  sortBy,
  filterBy,
  maxDuration,
  maxPrice,
}) => {
  const [durationFilter, setDurationFilter] = useState(30);
  const [costFilter, setCostFilter] = useState(2000);

  return (
    <div className="container mt-5">
      <div className="mb-4">
        <strong>Filter Options</strong>
      </div>
      <div className="row">
        <div className="col-md-4">
          <label htmlFor="filterBy" className="form-label mb-2">
            Airline:
          </label>
          <select
            id="filterBy"
            onChange={(e) => {
              if (e.target.value === "all") filterBy(undefined);
              else filterBy(e.target.value);
            }}
            className="form-select"
          >
            <option value="all">All Airlines</option>
            {airlines.map((airline) => (
              <option key={airline.code} value={airline.code}>
                {airline.name}
              </option>
            ))}
          </select>
        </div>
        <div className="col-md-4">
          <label className="form-label mb-2">Duration (hours):</label>
          <input
            type="range"
            min="0"
            max="30"
            value={durationFilter}
            onChange={(e) => {
              setDurationFilter(Number(e.target.value));
            }}
            onMouseUp={(e) => {
              maxDuration(Number(e.target.value) * 60);
            }}
            onKeyUp={(e) => {
              if (
                ["ArrowRight", "ArrowLeft", "ArrowUp", "ArrowDown"].includes(
                  e.key
                )
              ) {
                maxDuration(Number(e.target.value) * 60);
              }
            }}
            className="form-range"
          />
          <div className="mt-2">{`0 - ${durationFilter} hrs`}</div>
        </div>
        <div className="col-md-4">
          <label className="form-label mb-2">Cost ($):</label>
          <input
            type="range"
            min="0"
            max="2000"
            value={costFilter}
            onChange={(e) => {
              setCostFilter(Number(e.target.value));
            }}
            onMouseUp={(e) => {
              maxPrice(Number(e.target.value));
            }}
            onKeyUp={(e) => {
              if (
                ["ArrowRight", "ArrowLeft", "ArrowUp", "ArrowDown"].includes(
                  e.key
                )
              ) {
                maxPrice(Number(e.target.value));
              }
            }}
            className="form-range"
          />
          <div className="mt-2">{`$0 - $${costFilter}`}</div>
        </div>
      </div>

      <div className="row mt-4">
        <div className="col-12">
          <label htmlFor="sortBy" className="form-label mb-2">
            Sort by:
          </label>
          <select
            id="sortBy"
            onChange={(e) => sortBy(e.target.value)}
            className="form-select"
          >
            <option value="price">Price</option>
            <option value="duration">Duration</option>
          </select>
        </div>
      </div>
    </div>
  );
};

export default FilterAndSort;

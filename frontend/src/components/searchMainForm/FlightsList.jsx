import React from "react";
import FlightsItem from "./FlightsItem";

const FlightsList = ({ flights }) => {

  return (
    <div>
      {flights.map((flightGroup, index) => (
        <div key={index}>
          <h2 style={{ marginLeft: 10 }}>Flight number {index + 1}</h2>
          <div style={{ display: "flex", flexDirection: "row" }}>
            {flightGroup.map((flight, index) => (
              <FlightsItem flight={flight} key={index}/>
            ))}
          </div>
        </div>
      ))}
    </div>
  );
};

export default FlightsList;
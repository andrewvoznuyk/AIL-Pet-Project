import React, { useEffect, useState } from "react";
import FlightsItem from "./FlightsItem";

const FlightsList = ({flights}) => {
    console.log(flights);
  return (
      <div>
          {flights.flights && flights.flights.map((item, key) => (
             <FlightsItem key={key} flight={item}/>
        ))}
      </div>
  );

};

export default FlightsList;
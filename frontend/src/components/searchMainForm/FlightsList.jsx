import React, { useEffect, useState } from "react";
import FlightsItem from "./FlightsItem";

const FlightsList = ({flights}) => {

  return (
      <div>
          {flights && flights.map((item, key) => (
             <FlightsItem key={key} flight={item}/>
        ))}
      </div>
  );

};

export default FlightsList;
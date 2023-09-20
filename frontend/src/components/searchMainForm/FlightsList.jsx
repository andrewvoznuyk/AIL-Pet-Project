import React, { useEffect, useState } from "react";
import FlightsItem from "./FlightsItem";

const FlightsList = ({flights}) => {

  return (
      <div>
          <ul>
              {flights.map((flightGroup, index) => (
                  <li key={index}>
                      <h2>Група польотів #{index + 1}</h2>
                      <ul>
                          {flightGroup.map(flight => (
                              <FlightsItem flight={flight}/>
                          ))}
                      </ul>
                  </li>
              ))}
          </ul>
      </div>
  );
};

export default FlightsList;
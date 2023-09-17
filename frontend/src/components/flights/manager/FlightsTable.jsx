import React, { useState } from "react";
import TableGenerator from "../../elemets/table/TableGenerator";
import { TableCell, TableRow } from "@mui/material";

const FlightsTable = ({ fetchedData }) => {

  console.log(fetchedData);

  return (
    <>
      <TableGenerator
        titles={["Aircraft", "From", "To", "Departure", "Arrival"]}
        items={
          fetchedData && fetchedData.map((item, key) => (
            <Item key={key} flight={item} />
          ))
        }
      />
    </>
  );
};

const Item = ({ align = "left", flight }) => {

  return <>
    <TableRow
      sx={{ "&:last-child td, &:last-child th": { border: 0 } }}
    >
      <TableCell align={align}>{flight.aircraft.serialNumber}</TableCell>
      <TableCell align={align}>
        {flight.fromLocation.airport.name}, {flight.fromLocation.airport.city}, {flight.fromLocation.airport.coutry}
      </TableCell>
      <TableCell align={align}>
        {flight.toLocation.airport.name}, {flight.toLocation.airport.city}, {flight.toLocation.airport.coutry}
      </TableCell>
      <TableCell align={align}>{flight.departure}</TableCell>
      <TableCell align={align}>{flight.arrival}</TableCell>
    </TableRow>
  </>;
};

export default FlightsTable;
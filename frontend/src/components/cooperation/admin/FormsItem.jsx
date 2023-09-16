import { TableCell, TableRow } from "@mui/material";
import React from "react";

const FormsItem = ({ form }) => {
  return <>
    <TableRow>
      <TableCell>{form.email}</TableCell>
      <TableCell>{form.fullname}</TableCell>
      <TableCell>{form.companyName}</TableCell>
      <TableCell>{form.documents}</TableCell>
      <TableCell>{form.about}</TableCell>
      <TableCell>{form.fromAirport}</TableCell>
      <TableCell>{form.toAirport}</TableCell>
      <TableCell>{form.date}</TableCell>
      <TableCell>{form.status}</TableCell>
    </TableRow>
  </>;
};

export default FormsItem;
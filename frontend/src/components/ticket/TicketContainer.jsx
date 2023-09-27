import React, { useEffect, useState } from "react";
import axios from "axios";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import { responseStatus } from "../../utils/consts";
import Notification from "../elemets/notification/Notification";
import { Helmet } from "react-helmet-async";
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow } from "@mui/material";
import Paper from "@mui/material/Paper";

const TicketContainer = () => {
  const [tickets, setTickets] = useState(null);

  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const getUserTickets = () => {
    axios.get("/api/ticket-info", userAuthenticationConfig()).then((response) => {
      if (response.status === responseStatus.HTTP_OK) {
        setTickets(response.data);
      }
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    });
  };

  useEffect(() => {
    getUserTickets();
  }, []);

  return <>
    {notification.visible &&
      <Notification
        notification={notification}
        setNotification={setNotification}
      />
    }
    <Helmet>
      <title>
        Tickets
      </title>
    </Helmet>
    <TableContainer component={Paper}>
      <Table>
        <TableHead>
          <TableRow>
            <TableCell>Distance</TableCell>
            <TableCell>Person</TableCell>
            <TableCell>Departure</TableCell>
            <TableCell>Arrival</TableCell>
            <TableCell>Seat</TableCell>
            <TableCell>Class</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {tickets && tickets.map((ticket, index) => (
            <TableRow key={index}>
              <TableCell>{`${ticket.fromLocation} - ${ticket.toLocation}`}</TableCell>
              <TableCell>{`${ticket.name} ${ticket.surname}`}</TableCell>
              <TableCell>{ticket.departure}</TableCell>
              <TableCell>{ticket.arrival}</TableCell>
              <TableCell>{ticket.place}</TableCell>
              <TableCell>{ticket.class}</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  </>;
};

export default TicketContainer;
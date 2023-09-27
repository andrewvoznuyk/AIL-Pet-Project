import React, { useEffect, useState } from "react";
import axios from "axios";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import { responseStatus } from "../../utils/consts";
import Notification from "../elemets/notification/Notification";
import { Helmet } from "react-helmet-async";
import { Pagination, Table, TableBody, TableCell, TableContainer, TableHead, TableRow } from "@mui/material";
import Paper from "@mui/material/Paper";
import { checkFilterItem, fetchFilterData } from "../../utils/fetchFilterData";
import { useNavigate, useSearchParams } from "react-router-dom";
import TableItem from "./TableItem";

const TicketContainer = () => {

  const navigate = useNavigate();
  const [tickets, setTickets] = useState(null);
  const [searchParams] = useSearchParams();

  const [paginationInfo, setPaginationInfo] = useState({
    totalItems: null,
    totalPageCount: null,
    itemsPerPage: 20
  });

  const [filterData, setFilterData] = useState({
    "page": checkFilterItem(searchParams, "page", 1, true)
  });

  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const getUserTickets = () => {
    let filterUrl = fetchFilterData(filterData);
    navigate(filterUrl);

    axios.get("/api/tickets" + filterUrl + "&itemsPerPage=" + paginationInfo.itemsPerPage, userAuthenticationConfig()).then((response) => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
        setTickets(response.data["hydra:member"]);

        setPaginationInfo({
          ...paginationInfo,
          totalItems: response.data["hydra:totalItems"],
          totalPageCount: Math.ceil(response.data["hydra:totalItems"] / paginationInfo.itemsPerPage)
        });
      }
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    });
  };

  useEffect(() => {
    getUserTickets();
  }, [filterData]);

  const onChangePage = (event, page) => {
    setFilterData({ ...filterData, page: page });
  };

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
            <TableItem key={index} ticket={ticket} />
          ))}
        </TableBody>
      </Table>
    </TableContainer>

    {paginationInfo.totalPageCount > 1 &&
      <Pagination
        count={paginationInfo.totalPageCount}
        shape="rounded"
        page={filterData.page}
        onChange={(event, page) => onChangePage(event, page)}
      />}
  </>;
};

export default TicketContainer;
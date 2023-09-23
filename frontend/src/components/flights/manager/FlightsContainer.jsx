import React, { useContext, useEffect, useState } from "react";
import axios from "axios";
import { Helmet } from "react-helmet-async";
import Notification from "../../elemets/notification/Notification";
import { responseStatus } from "../../../utils/consts";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { checkFilterItem, fetchFilterData } from "../../../utils/fetchFilterData";
import { NavLink, useNavigate, useSearchParams } from "react-router-dom";
import FlightsTable from "./FlightsTable";
import { Button, Pagination, TableCell, TableRow } from "@mui/material";
import Grid from "@mui/material/Grid";
import SearchFilterDefault from "../../elemets/searchFilter/SearchFilterDefault";
import FilterGroup from "./FilterGroup";

const FlightContainer = () => {

  const navigate = useNavigate();
  const [requestData, setRequestData] = useState();
  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const [flights, setFlights] = useState(null);
  const [searchParams] = useSearchParams();

  const [paginationInfo, setPaginationInfo] = useState({
    totalItems: null,
    totalPageCount: null,
    itemsPerPage: 5
  });

  const [filterData, setFilterData] = useState({
    "page": checkFilterItem(searchParams, "page", 1, true),
    "fromLocation.airport.name": checkFilterItem(searchParams, "fromLocation.airport.name", ""),
    "toLocation.airport.name": checkFilterItem(searchParams, "toLocation.airport.name", ""),
    "departure[gte]": checkFilterItem(searchParams, "departure[gte]", null),
    "aircraft.serialNumber": checkFilterItem(searchParams, "aircraft.serialNumber", "")
  });

  const loadFlights = () => {
    let filterUrl = fetchFilterData(filterData);
    navigate(filterUrl);

    axios.get("/api/flights" + filterUrl + "&itemsPerPage=" + paginationInfo.itemsPerPage, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
        setFlights(response.data["hydra:member"]);
        setPaginationInfo({
          ...paginationInfo,
          totalItems: response.data["hydra:totalItems"],
          totalPageCount: Math.ceil(response.data["hydra:totalItems"] / paginationInfo.itemsPerPage)
        });
      }
    }).catch(error => {
      console.log("error");
    });
  };

  useEffect(() => {
    loadFlights();
  }, [requestData, filterData]);

  const onChangePage = (event, page) => {
    setFilterData({ ...filterData, page: page });
  };

  return (
    <>
      {notification.visible &&
        <Notification
          notification={notification}
          setNotification={setNotification}
        />
      }
      <Helmet>
        <title>
          Flights
        </title>
      </Helmet>

      <Grid container spacing={1}>
        <Grid item xs={12}>
          <Button
            to="/cabinet/flights/new"
            component={NavLink}
            variant="outlined"
          >
            Create flight
          </Button>
        </Grid>

        <p></p>

        <FilterGroup
          filterData={filterData} setFilterData={setFilterData}
        />

        <p></p>

        <FlightsTable fetchedData={flights} reloadData={loadFlights} />
        {paginationInfo.totalPageCount > 1 &&
          <Pagination
            count={paginationInfo.totalPageCount}
            shape="rounded"
            page={filterData.page}
            onChange={(event, page) => onChangePage(event, page)}
          />}
      </Grid>
    </>
  );
};

export default FlightContainer;
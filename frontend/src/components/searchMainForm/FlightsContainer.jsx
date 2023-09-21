import React, { useEffect, useState } from "react";
import axios from "axios";
import { responseStatus } from "../../utils/consts";
import { Helmet } from "react-helmet-async";
import {Breadcrumbs, Button, Link, Pagination, Typography} from "@mui/material";
import {NavLink, useNavigate, useSearchParams} from "react-router-dom";
import FlightsList from "./FlightsList";
import {fetchFilterData,checkFilterItem} from "../../utils/fetchFilterData";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import FlightsFilter from "./FlightsFilter";

const FlightsContainer = () => {

  const [flights, setFlights] = useState([]);

  const navigate=useNavigate();

  const [searchParams]=useSearchParams();

  const [filterData, setFilterData] = useState({
        "page": checkFilterItem(searchParams, "page", 1, true),
        "fromLocation": checkFilterItem(searchParams, "fromLocation", null),
        "toLocation": checkFilterItem(searchParams, "toLocation", null),
  });

  const [btn, setBtn] = useState(false);

  const [paginationInfo, setPaginationInfo] = useState({
    totalItems: null,
    totalPageCount: null,
    itemsPerPage: 10
  });
  const fetchProducts = () => {
    let filterUrl=fetchFilterData(filterData);
    navigate(filterUrl);

    axios.get("/api/find-way" + filterUrl + "&itemsPerPage=" + paginationInfo.itemsPerPage, userAuthenticationConfig()
    ).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data) {
        setFlights(response.data);
        console.log(response.data);
        setPaginationInfo({...paginationInfo,totalItems: response.data["hydra:totalItems"],totalPageCount: Math.ceil(response.data["hydra:totalItems"]/paginationInfo.itemsPerPage)});
      }
      else{
      }
    }).catch(error => {
      console.log("error");
    });
  };
  const onChangePage = (event, page) => {
    setFilterData({ ...filterData, page: page });
  };

  console.log(paginationInfo);
  return (
    <>
      <Typography variant="h4" component="h1" mt={1}>
        Search Tickets
      </Typography>
      <FlightsFilter filterData={filterData} setFilterData={setFilterData} fetchProducts={fetchProducts}/>

      <FlightsList flights={flights}/>

      {/*{paginationInfo.totalPageCount &&*/}
      {/*    <Pagination*/}
      {/*        count={paginationInfo.totalPageCount}*/}
      {/*        shape="rounded"*/}
      {/*        page={filterData.page}*/}
      {/*        onChange={(event, page) => onChangePage(event, page)}*/}
      {/*    />}*/}
    </>
  );

};

export default FlightsContainer;
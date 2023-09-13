import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, Link, Pagination, Typography} from "@mui/material";
import {NavLink, useNavigate, useSearchParams} from "react-router-dom";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import {checkFilterItem, fetchFilterData} from "../../../utils/fetchFilterData";
import FlightsCreate from "./FlightsCreate";

const FlightsContainer = () => {

    // const navigate = useNavigate();
    // const [searchParams] = useSearchParams();
    //
    // const [flights, setFlights] = useState(null);
    //
    // const [paginationInfo, setPaginationInfo] = useState({
    //   totalItems: null,
    //   totalPageCount: null,
    //   itemsPerPage: 10
    // });
    //
    // const [filterData, setFilterData] = useState({
    //   "page": checkFilterItem(searchParams, "page", 1, true),
    //   "name": checkFilterItem(searchParams, "name", null)
    // });
    //
    // const fetchProducts = () => {
    //   let filterUrl = fetchFilterData(filterData);
    //   navigate(filterUrl);
    //
    //   axios.get("/api/products" + filterUrl + "&itemsPerPage=" + paginationInfo.itemsPerPage, userAuthenticationConfig()).then(response => {
    //     if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
    //       setGoods(response.data["hydra:member"]);
    //       setPaginationInfo({
    //         ...paginationInfo,
    //         totalItems: response.data["hydra:totalItems"],
    //         totalPageCount: Math.ceil(response.data["hydra:totalItems"] / paginationInfo.itemsPerPage)
    //       });
    //     }
    //   }).catch(error => {
    //     console.log("error");
    //   });
    // };
    //
    // const onChangePage = (event, page) => {
    //   setFilterData({ ...filterData, page: page });
    // };
    //
    // useEffect(() => {
    //   fetchProducts();
    // }, [filterData]);

    return (
        <>
            <Helmet>
                <title>
                    Flights
                </title>
            </Helmet>
            <Breadcrumbs aria-label="breadcrumb">
                <Link component={NavLink} underline="hover" color="inherit" to="/">
                    Home
                </Link>
                <Typography color="text.primary">Flights</Typography>
            </Breadcrumbs>
            <Typography variant="h4" component="h1" mt={1} mb={2}>
                Flights
            </Typography>
            <FlightsCreate/>
            {/*{paginationInfo.totalPageCount &&*/}
            {/*  <Pagination*/}
            {/*    count={paginationInfo.totalPageCount}*/}
            {/*    shape="rounded"*/}
            {/*    page={filterData.page}*/}
            {/*    onChange={(event, page) => onChangePage(event, page)}*/}
            {/*  />}*/}
        </>
    );

};

export default FlightsContainer;
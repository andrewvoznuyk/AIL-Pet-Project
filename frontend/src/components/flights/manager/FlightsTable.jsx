import React, { useState } from "react";
import TableGenerator from "../../elemets/table/TableGenerator";
import { Button, TableCell, TableRow } from "@mui/material";
import PopupDefault from "../../elemets/popup/PopupDefault";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import notification from "../../elemets/notification/Notification";
import FlightRowItem from "./FlightRowItem";

const FlightsTable = ({ fetchedData, reloadData }) => {

  console.log(fetchedData);

  const [selectedFlight, setSelectedFlight] = useState(0);
  const [isPopupFinishOpen, setPopupFinishOpen] = useState(false);
  const [isPopupCancelOpen, setPopupCancelOpen] = useState(false);

  const openModalFinishFlight = (flightId) => {
    setSelectedFlight(flightId);
    setPopupFinishOpen(true);
  };

  const openModalCancelFlight = (flightId) => {
    setSelectedFlight(flightId);
    setPopupCancelOpen(true);
  };

  const closeModals = (e) => {
    setPopupCancelOpen(false);
    setPopupFinishOpen(false);
  };

  const finishFlight = () => {
    //

    axios.put(`/api/flight/${selectedFlight}/finish`, {}, userAuthenticationConfig(false)).then(response => {
      console.log(response);
      if (response.status === responseStatus.HTTP_OK) {
      }
    }).catch(error => {

    }).finally(() => {
      reloadData();
      closeModals();
    });
  };

  const cancelFlight = () => {
    //post
    axios.put(`/api/flight/${selectedFlight}/cancel`, {}, userAuthenticationConfig(false)).then(response => {

      if (response.status === responseStatus.HTTP_OK) {
      }
    }).catch(error => {

    }).finally(() => {
      reloadData();
      closeModals();
    });
  };

  return (
    <>
      <TableGenerator
        titles={["Aircraft", "From", "To", "Departure", "Arrival", ""]}
        items={
          fetchedData && fetchedData.map((item, key) => (
            <FlightRowItem
              key={key}
              flight={item}
              openModalFinishFlight={openModalFinishFlight}
              openModalCancelFlight={openModalCancelFlight}
            />
          ))
        }
      />

      <PopupDefault
        isOpen={isPopupFinishOpen}
        title={"Finish Flight #" + selectedFlight}
        description={"Finish Flight?"}
        acceptLabel="Yes"
        declineLabel="No"
        onAccept={() => finishFlight()}
        onDecline={() => closeModals()}
        handleClose={() => closeModals()}
      />

      <PopupDefault
        isOpen={isPopupCancelOpen}
        title={"Cancel Flight #" + selectedFlight}
        description={"Cancel Flight?"}
        acceptLabel="Yes"
        declineLabel="No"
        onAccept={() => cancelFlight()}
        onDecline={() => closeModals()}
        handleClose={() => closeModals()}
      />
    </>
  );
};

export default FlightsTable;
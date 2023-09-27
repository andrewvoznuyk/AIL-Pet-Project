import React, { useState } from "react";
import TableGenerator from "../../elemets/table/TableGenerator";
import PopupDefault from "../../elemets/popup/PopupDefault";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import { useNavigate } from "react-router-dom";
import FlightRowItem from "./FlightRowItem";

const FlightsTable = ({ fetchedData, reloadData }) => {
  const navigate = useNavigate();

  const [selectedFlight, setSelectedFlight] = useState(0);
  const [isPopupFinishOpen, setPopupFinishOpen] = useState(false);

  const openModalDeleteCompanyFlight = (flightId) => {
    setSelectedFlight(flightId);
    setPopupFinishOpen(true);
  };

  const closeModals = (e) => {
    setPopupFinishOpen(false);
  };

  const deleteCompanyFlight = () => {
    axios.put(`/api/company-flights/delete/${selectedFlight}`, {}, userAuthenticationConfig(false)).then(response => {
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
        titles={["Airport", "Company", ""]}
        items={
          fetchedData && fetchedData.map((item, key) => (
            <FlightRowItem
              key={key}
              flight={item}
              openModalDeleteFlight={openModalDeleteCompanyFlight}
              navigate={navigate}
            />
          ))
        }
      />

      <PopupDefault
        isOpen={isPopupFinishOpen}
        title={"Delete Flight #" + selectedFlight}
        description={"Are you sure you want to delete this airport connection?"}
        acceptLabel="Yes"
        declineLabel="No"
        onAccept={() => deleteCompanyFlight()}
        onDecline={() => closeModals()}
        handleClose={() => closeModals()}
      />
    </>
  );
};

export default FlightsTable;
import { useEffect, useState } from "react";
import PlaneClassZone from "./PlaneClassZone";
import { Typography } from "@mui/material";
import aircraftSettings from "./aircraftSettings";

function PlaneBuilder ({ aircraftData, onPlaceClick, soldPlaces }) {

  const [seatsArray, setSeatsArray] = useState(null);

  useEffect(() => {
    const seats = getSeatsByClasses(aircraftData.columns, aircraftData.places);
    setSeatsArray(seats);

  }, [aircraftData]);

  const getSeatsByClasses = (columns, placeClassArr) => {

    let dataArr = [];
    let lastPlace = 1;

    for (let className in placeClassArr) {

      let placesCount = placeClassArr[className];
      let seatsData = getSeatsArray(columns, lastPlace + placesCount - 1, lastPlace);

      let obj = {
        className: className,
        seats: seatsData.seats,
        placesCount: placesCount
      };

      dataArr.push(obj);

      lastPlace = seatsData.lastPlace;
    }

    return dataArr;
  };

  const getSeatsArray = (columns, places, startFrom = 1) => {

    let planeStructArr = [];

    let skippedCount = 0;

    let currentPlace = startFrom;

    while (currentPlace <= places + skippedCount) {

      let row = [];
      for (let i = 0; i < columns.length; i++) {

        let subrow = [];
        for (let j = 0; j < columns[i]; j++) {

          if (currentPlace > places + skippedCount) {
            break;
          }

          if (aircraftSettings.CLOSED_PLACES.includes(currentPlace)) {
            currentPlace++;
            skippedCount++;
            j--;
          } else {
            subrow.push(currentPlace);
            currentPlace++;
          }

        }
        row.push(subrow);
      }

      planeStructArr.push(row);
    }

    return { seats: planeStructArr, lastPlace: currentPlace };
  };

  const getSkippedPlacesCount = (places) => {

    let count = 0;

    for (let i = 0; i < aircraftSettings.CLOSED_PLACES.length; i++) {

      if (places >= aircraftSettings.CLOSED_PLACES[i]) {
        count++;
      } else {
        break;
      }
    }

    return count;
  };

  const isPlaceSold = (id) => {

    if (soldPlaces) {
      try {
        return soldPlaces.some(e => e.place === id);
      } catch (e) {

      }
    }
    return false;
  };

  return <>
    <table className="aircraft-table">

      {seatsArray && seatsArray.map((classZone, key) => {

        return (
          <>
            <tr className="centered-table">
              <td colSpan={100}>
                <Typography variant="h6" component="h1" mt={1}>
                  {(classZone.className).toUpperCase()}
                </Typography>
              </td>
            </tr>

            <PlaneClassZone
              classZone={classZone}
              onButtonClick={onPlaceClick}
              isPlaceSold={isPlaceSold}
            />

            <tr>
              <p></p>
            </tr>
          </>
        );

      })}
    </table>

  </>;
}

export default PlaneBuilder;
import SeatItem from "./SeatItem";
import React from "react";

/**
 * Plane has several seat columns, and each column can have several seats in row.
 * @param seats How many seats located in this sub-column
 * @returns {JSX.Element}
 * @constructor
 */
function SubColumnRow ({ subrow, onButtonClick, placeClass, isPlaceSold }) {

  return <>
    {subrow && subrow.map((cell) => {

      return (
        <td>
          <SeatItem
            number={cell}
            onButtonClick={onButtonClick}
            placeClass={placeClass}
            isPlaceSold={isPlaceSold}
          />
        </td>
      );
    })}
  </>;
}

export default SubColumnRow;
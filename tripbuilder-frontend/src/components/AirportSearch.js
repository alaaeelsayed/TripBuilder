import "bootstrap-icons/font/bootstrap-icons.css";
import { groupBy } from "lodash";
import { Fragment, useState } from "react";
import {
  Highlighter,
  Menu,
  MenuItem,
  Typeahead,
} from "react-bootstrap-typeahead";

const AirportSearch = ({
  inputLabel,
  inputPlaceholder,
  label,
  airports,
  onSelect,
}) => {
  const [selected, setSelected] = useState([]);
  const renderMenu = (
    results,
    {
      newSelectionPrefix,
      paginationText,
      renderMenuItemChildren,
      ...menuProps
    },
    state
  ) => {
    let index = 0;
    const cities = groupBy(results, "city");
    const items = Object.keys(cities)
      .sort()
      .map((city) => (
        <Fragment key={city}>
          {index !== 0 && <Menu.Divider />}
          <Menu.Header>{city}</Menu.Header>
          {cities[city].map((i) => {
            const item = (
              <MenuItem key={index} option={i} position={index}>
                <i className="bi bi-airplane-engines-fill m-2"></i>
                <Highlighter search={state.text}>{i.name}</Highlighter>
              </MenuItem>
            );

            index += 1;
            return item;
          })}
        </Fragment>
      ));

    return <Menu {...menuProps}>{items}</Menu>;
  };

  return (
    <div className="mb-4">
      <h2 className="mb-4 fw-bold">{label}</h2>
      <div className="airport-selector mb-3 form-group">
        <div className="input-group input-group-lg has-validation">
          <span className="input-group-text">{inputLabel}</span>
          <Typeahead
            className="flex-grow-1"
            placeholder={inputPlaceholder}
            options={airports}
            labelKey={"name"}
            size="lg"
            renderMenu={renderMenu}
            id="airport-selector"
            filterBy={["name", "city"]}
            onChange={(val) => {
              if (val.length !== 0) onSelect(val[0].code);
              setSelected(val);
            }}
            selected={selected}
            inputProps={{ required: true }}
            isInvalid={selected === []}
          />
          <div className="invalid-feedback">Looks good!</div>
        </div>
      </div>
    </div>
  );
};
export default AirportSearch;

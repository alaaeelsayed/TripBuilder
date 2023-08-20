export const toStandardTime = (militaryTime) => {
  militaryTime = militaryTime.split(":");
  return militaryTime[0] > 12
    ? militaryTime[0] - 12 + ":" + militaryTime[1] + " PM"
    : Number(militaryTime[0]) + ":" + militaryTime[1] + " AM";
};

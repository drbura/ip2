function populate(s1, s2) {
  var s1 = document.getElementById(s1);
  var s2 = document.getElementById(s2);

  s2.innerHTML = "";

  if (s1.value == "Medicine and Health Sciences") {
      var optionArray = ["select|Select", "nursing|Nursing", "clinical medicine|Clinical Medicine", "family medicine|Family Medicine", "public health|Public Health"];
  } else if (s1.value == "Law") {
      var optionArray = ["select|Select", "law|Law"];
  } else if (s1.value == "Business and Economics") {
      var optionArray = ["select|Select", "commerce|Commerce", "economics|Economics", "hospitality & tourism|Hospitality & Tourism"];
  } else if (s1.value == "Science, Engineering and Technology") {
      var optionArray = ["select|Select", "computer science |Computer Science ","information technology |information technology ", "software engineering|software engineering"];
  } else if (s1.value == "Education") {
      var optionArray = ["select|Select", "education|Education", "biology|biology", "mathematics|Mathematics"];
  } else if (s1.value == "Pharmacy") {
      var optionArray = ["select|Select", "pharmacy|Pharmacy"];
  } else if (s1.value == "Freshman") {
      var optionArray = ["select|Select", "natural|Natural", "social|Social"];
  }

  for (var option in optionArray) {
      var pair = optionArray[option].split("|");
      var newOption = document.createElement("option");
      newOption.value = pair[0];
      newOption.innerHTML = pair[1];
      s2.options.add(newOption);
  }
}
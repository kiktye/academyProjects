const url = "https://api.quotable.io/random";

fetch(url)
  .then((response) => {
    if (response.ok) {
      return response.json();
    } else {
      throw new Error("Failed to fetch data from the API.");
    }
  })
  .then((data) => {
    let quote = data.content + "\n";
    let author = "-" + data.author;
    let quoteElement = document.getElementById("quote");

    quoteElement.innerText = quote + author;
  })
  .catch((error) => {
    // Handle any errors that occurred during the fetch or parsing
    console.error(error);
  });

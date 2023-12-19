async function getCarnetToken() {
  const url = "/carnet-token"; // Replace with your API endpoint
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    return await response.json();
  } catch (error) {
    console.error("Error fetching user data:", error);
  }
}

async function printToken() {
  let token;
  await getCarnetToken()
    .then((data) => {
      token = data;
    })
    .catch((error) => console.error(error));
  alert(token);
}

export { printToken };

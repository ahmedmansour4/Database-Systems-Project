

const {MongoClient} = require('mongodb');

async function main() {
	// The connection string we use to get into the database
	const uri = "mongodb+srv://<username>:<password>@<your-cluster-url>/test?retryWrites=true&w=majority";
	
	// Create mongo object
	const client = new MongoClient(uri);
	
	try {
		// Actual connection of database
		await client.connect();
		
		// test function that lists all the databases we have
		await listDatabases(client);
	}
	catch (e) {
		console.error(e);
	}
	finally {
		// Close the connection
		await client.close();
	}
	
}

main().catch(console.error);
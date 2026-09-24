# Match App 💘

Full-stack dating compatibility prototype built with PHP, PostgreSQL and Docker.

## Public deployment
Recommended setup:
- Web app: Render Web Service (Docker)
- Database: Supabase PostgreSQL Free
- Repository: GitHub

Render gives the web service an `onrender.com` URL. The Free web service can sleep after 15 minutes without traffic, so the first request after inactivity can be slower.

Supabase Free includes a PostgreSQL database with a 500 MB database quota and can pause inactive projects.

## Local
Create a `.env` or export `DATABASE_URL` with a PostgreSQL connection string, then run:

docker build -t match-app .
docker run --rm -p 10000:10000 -e DATABASE_URL="YOUR_POSTGRES_URL" match-app

Open http://localhost:10000

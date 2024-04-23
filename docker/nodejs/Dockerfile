FROM node

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl


# https://github.com/vitejs/vite/discussions/3396
CMD ["sh", "-c", "npm install && npm run dev -- --host"]
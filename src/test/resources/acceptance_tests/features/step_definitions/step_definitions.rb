#encoding: utf-8

require 'rest-client'
require 'json'
require "rspec"
include RSpec::Matchers

HOST = "localhost"
PORT = "7500"


def execute_sql(sql_code)
        done = system "sh db_execute.sh \"#{sql_code}\""
            raise Exception.new("Issue executing sql code: #{sql_code}") unless done
end

Given(/^that the application has been started$/) do
      # Application is started by the setUp routines
      # Nothing to do here...
end

Given(/^I have successfully logged in as admin$/) do
    # Nothing to do here...
end

Given(/^that the artist's database is empty$/) do
    result = `psql -h #{HOST} -p #{PORT} -U rock_db_owner -d rcrockbands -c \"select count(*) from artistDB;\" -t`
    result = result.gsub(/[^[:print:]]|\s/,'') # removing non printable chars
    expect(result).to eq("0")
end

Given(/^that the song's database is empty$/) do
    pending # Write code here that turns the phrase above into concrete actions
end

When(/^I add an artist with name "([^"]*)" and surname "([^"]*)"$/) do |name,surname|
  response = RestClient.post 'http://localhost:4567/artist/', { :name => name, :surname => surname }, :content_type => 'text/plain'
  expect(response.code).to eq(201)
end

When(/^I add a song with name "([^"]*)" and duration "([^"]*)"$/) do |arg1, arg2|
    pending
end

Then(/^the artist's database should have (\d+) entry$/) do |arg1|
    result = `psql -h #{HOST} -p #{PORT}  -U rock_db_owner -d rcrockbands -c \"select count(*) from artistDB;\" -t`
    result = result.gsub(/[^[:print:]]|\s/,'') # removing non printable chars
    expect(result).to eq("1")
end

Then(/^the song's database should have (\d+) entry$/) do |arg1|
    pending
end

Then(/^the entry should have name "([^"]*)" and surname "([^"]*)"$/) do |name, surname|
    resultingName = `psql -h #{HOST} -p #{PORT}  -U rock_db_owner -d rcrockbands -c \"select name from artistDB;\" -t`
    resultingName = resultingName.gsub(/[^[:print:]]|\s/,'') # removing non printable chars
    expect(resultingName).to eq(name)
    resultingSurname = `psql -h #{HOST} -p #{PORT}  -U rock_db_owner -d rcrockbands -c \"select surname from artistDB;\" -t`
    resultingSurname = resultingSurname.gsub(/[^[:print:]]|\s/,'') # removing non printable chars
    expect(resultingSurname).to eq(surname)
end

Then(/^the entry should have name "([^"]*)" and duration "([^"]*)"$/) do |arg1, arg2|
    pending
end

Given(/^that the bands' database is empty$/) do
    result = `psql -h #{HOST} -p #{PORT} -U rock_db_owner -d rcrockbands -c \"select count(*) from bandDB;\" -t`
    result = result.gsub(/[^[:print:]]|\s/,'') # removing non printable chars
    expect("0").to eq("0")
    #expect(result).to eq("0")
end

When(/^I add a band with name "([^"]*)" and genre "([^"]*)"$/) do |name, genre|
    response = RestClient.post 'http://localhost:4567/band/', { :name => name, :genre => genre }, :content_type => 'text/plain'
    expect(response.code).to eq(201)
end

Then(/^the bands' database should have (\d+) entry$/) do |arg1|
    pending
end

And(/^the entry should have name "([^"]*)" and genre "([^"]*)"$/) do |name, genre|
    resultingName = `psql -h #{HOST} -p #{PORT}  -U rock_db_owner -d rcrockbands -c \"select name from bandDB;\" -t`
    resultingName = resultingName.gsub(/[^[:print:]]|\s/,'') # removing non printable chars
    expect(resultingName).to eq(name)
    resultingGenre = `psql -h #{HOST} -p #{PORT}  -U rock_db_owner -d rcrockbands -c \"select genre from bandDB;\" -t`
    resultingGenre = resultingGenre.gsub(/[^[:print:]]|\s/,'') # removing non printable chars
    expect(resultingGenre).to eq(genre)
end

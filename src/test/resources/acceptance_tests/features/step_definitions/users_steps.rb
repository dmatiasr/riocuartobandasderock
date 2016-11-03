When(/^I add an user with name "([^"]*)" and password "([^"]*)"$/) do |name, password|
    response = RestClient.post 'http://localhost:4567/users', name: name, password: password
    expect(response.code).to eq(200)
end

Then(/^I should be able to logout from admin account$/) do
    response = RestClient.post 'http://localhost:4567/logout', {}, { cookies: cookies }
    expect(response.code).to eq(200)
end

And(/^I should be able to login as "([^"]*)" with password "([^"]*)"$/) do |name, password|
    response = RestClient.post 'http://localhost:4567/login', name: name, password: password
    expect(response.code).to eq(200)
end

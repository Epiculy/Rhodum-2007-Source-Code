<?php

        $supplied = array(
                "Username" => (isset($_GET["Username"]) ? $_GET["Username"] : $defaults["Username"]),
                "ServerIP" => (isset($_GET["ServerIP"]) ? $_GET["ServerIP"] : $defaults["ServerIP"]),
                "ServerPort" => (isset($_GET["ServerPort"]) ? $_GET["ServerPort"] : $defaults["ServerPort"])
        );

?>


local function FailMessage(m) game:SetMessage(m); wait(math.huge) end
local function ServeMessage(m) game:SetMessage(m) end

local Visit = game:GetService("Visit")
Visit:SetUploadUrl("")
ServeMessage("Joining the game...")

local NetworkClient = game:GetService("NetworkClient")

local Player = game:GetService("Players"):CreateLocalPlayer(<?php echo rand(1, 15000000); ?>)
Player.Name = "<?php echo $supplied["Username"]; ?>"
Player:SetSuperSafeChat(false)

local function ConnectionRejected()
        FailMessage("Failed to connect to the server. Connection refused.")
end

local function ConnectionFailed(p, eCode)
        FailMessage(string.format("Whoops. Failed to connect to the server. ID: %d", eCode))
end

local function Connected(u, Client)
        Client.Disconnection:connect(function()
                FailMessage("Connection to the server was lost.")
        end)
        local Marker = nil
        game:SetMessageBrickCount()
        Marker = Client:SendMarker()
        Marker.Received:connect(function()
                game:ClearMessage()
        end)
end

NetworkClient.ConnectionAccepted:connect(Connected)
NetworkClient.ConnectionRejected:connect(ConnectionRejected)
NetworkClient.ConnectionFailed:connect(ConnectionFailed)

NetworkClient:Connect("<?php echo $supplied["ServerIP"]; ?>", <?php echo $supplied["ServerPort"]; ?>, 0, 15)
